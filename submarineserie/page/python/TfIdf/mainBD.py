import mysql.connector, os
from imdb import IMDb

def get_series_poster(series_name):
    ia = IMDb()
    series_results = ia.search_movie(series_name)
    for series in series_results:
        if series['kind'] == 'tv series':
            ia.update(series)
            if 'cover url' in series:
                return series['cover url']
    return None


def connectBD():
    mydb = mysql.connector.connect(host="localhost",user="root",password="",database="submarineseries")
    return mydb

def countSeries(path):
    count = 0
    for _, folders, _ in os.walk(os.path.join(path, 'VF')):
        count += len(folders)
    return count
  
def keepSeries(path):
    count_Series = {}
    for folder in os.listdir(path):
        path_folder = os.path.join(path, folder)
        if os.path.isdir(path_folder):
            count_Series[folder] = countSeries(path_folder)
    return count_Series

def keepIdSeries(nom_serie):
    connexion = connectBD()
    query = "SELECT id_series FROM series WHERE nom = %s"
    valeurs = (nom_serie,)
    try:
        cursor = connexion.cursor()
        cursor.execute(query, valeurs)
        result = cursor.fetchone()
        if result is not None:
            id_serie = result[0]
            return id_serie
        else:
            return None
    except mysql.connector.Error as error:
        print(f"Erreur lors de la récupération de l'ID de la série : {error}")

def addSeriesInBd(series):
    mydb = connectBD()
    for  key, value in series.items():
        response = keepIdSeries(key)
        url = get_series_poster(key)
        serieName = key.capitalize()
        if not response:
            sql = "INSERT INTO series (nom, nb_saisons,image) VALUES (%s, %s, %s)"
            values = (serieName, value,url)
            try:
                mycursor = mydb.cursor()
                mycursor.execute(sql, values)
                mydb.commit()
            except mysql.connector.Error as error:
                print(f"Erreur lors de l'insertion des données : {error}")
            print("serie insérée")
        else :
            sql = "UPDATE series SET nb_saisons = %s WHERE id_series = %s "
            values = (value,response)
            try:
                mycursor = mydb.cursor()
                mycursor.execute(sql, values)
                mydb.commit()
            except mysql.connector.Error as error:
                print(f"Erreur lors de la modifications des données : {error}")
            print("serie modifié")

def keepIdMots(id_series, version):
    connexion = connectBD()
    query = "SELECT * FROM cles WHERE id_series = %s AND version = %s"
    valeurs = (id_series,version)
    try:
        cursor = connexion.cursor()
        cursor.execute(query, valeurs)
        result = cursor.fetchone()
        if result :
            return True
        else:
            return None
    except mysql.connector.Error as error:
        print(f"Erreur lors de la récupération de l'ID de la série : {error}")       

def deleteByKey(id_series, version):
    connexion = connectBD()
    query = "DELETE FROM cles WHERE id_series = %s AND version = %s"
    valeurs = (id_series, version)
    try:
        cursor = connexion.cursor()
        cursor.execute(query, valeurs)
        connexion.commit()
    except mysql.connector.Error as error:
        print(f"Erreur lors de la suppression des enregistrements : {error}")
    finally:
        cursor.close()
        connexion.close()

def insertValues (dico,version):
    connexion = connectBD()
    for serie, mots in dico.items():
        id_serie = keepIdSeries(serie)
        response = keepIdMots(id_serie,version)
        if response:
            deleteByKey (id_serie, version)
            print ("mot supprimé")
        print ("importé dans la table clé")
        for mot, ponderation in mots.items():
            sql = "INSERT INTO cles (id_series, mot_cle, frequence,version) VALUES (%s, %s, %s,%s)"
            number = "{:.4f}".format(ponderation)
            values = (id_serie, mot,number,version)
            mycursor = connexion.cursor()
            mycursor.execute(sql, values)
            connexion.commit()


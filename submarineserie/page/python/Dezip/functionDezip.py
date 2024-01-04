import re, os , zipfile, shutil, hashlib

def unzip_file(file_path):
    for dossier_racine, dossiers, fichiers in os.walk(file_path):
       for fichier in fichiers:
            if fichier.endswith(".zip"):
                path = os.path.join(dossier_racine, fichier)
                with zipfile.ZipFile(path, 'r') as zip_ref:     
                    zip_ref.extractall(file_path)
                os.remove(path)

def move_files_and_remove_subdirectories(directory):
    for root, dirs, files in os.walk(directory):
        for file in files:
            if not file.endswith('.sub') and not file.endswith(".srt") and not file.endswith(".SRT"):
                file_path = os.path.join(root, file)
                os.remove(file_path)
        for subdir in dirs:
            subdir_path = os.path.join(root, subdir)
            shutil.rmtree(subdir_path)

def calculate_file_hash(file_path, algorithm='sha256'):
    hash_object = hashlib.sha256()
    with open(file_path, 'rb') as file:
        for chunk in iter(lambda: file.read(4096), b''):
            hash_object.update(chunk)
    file_hash = hash_object.hexdigest()
    return file_hash

def display_file_hashes(directory):
    tabHash = []
    for root, dirs, files in os.walk(directory):
        for file in files:
            file_hash = calculate_file_hash(os.path.join(root, file))
            if file_hash in tabHash:
                os.remove(os.path.join(root, file))
            else:
                tabHash.append(file_hash)  


def displayFiles_zip(sous_titres_path):
    pattern = r'^\w+\d{2}(VF|VO)\.zip$'
    for dossier_racine, dossiers, fichiers in os.walk(sous_titres_path):
        for fichier in fichiers:
            if fichier.endswith(".zip") and re.match(pattern, fichier):
                path = os.path.join(dossier_racine, fichier)
                saison = fichier.split(".")[0]
                num_episode=re.search(r'\d{2}(?=VF|VO)', saison).group()
                newFilePath = dossier_racine+'/'+'Saison'+num_episode
                os.makedirs(newFilePath, exist_ok=True)
                try:
                    with zipfile.ZipFile(path, 'r') as zip_ref:
                        zip_ref.extractall(newFilePath)
                        for file in os.listdir(newFilePath):
                            if file.endswith('.zip'):
                                os.remove( os.path.join(newFilePath, file))
                except zipfile.BadZipFile:
                     print("Le fichier ZIP est corrompu.")
                except Exception as e:
                     print("Une erreur s'est produite lors du traitement du fichier ZIP :", str(e))
                unzip_file(newFilePath)
                move_files_and_remove_subdirectories(newFilePath)
                display_file_hashes(newFilePath)
                os.remove(path)



def moveFolder(path, folderDesti):
    shutil.move(path, folderDesti)
    displayFiles_zip(folderDesti)


def moveFile(folderRoot,folderDesti,NameSerie,file):
    num = re.search(r'\d{2}(?=\D|$)', file).group()
    nom_dossier = "Saison" + num
    if not os.path.exists(folderDesti+'/'+ nom_dossier):  
        os.mkdir(folderDesti+'/'+nom_dossier)
    if not os.path.exists(folderDesti+'/'+ nom_dossier+'/'+ file):
        shutil.move(os.path.join(folderRoot+'/'+NameSerie, file),folderDesti+'/'+ nom_dossier)

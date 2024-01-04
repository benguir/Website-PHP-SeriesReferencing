import re, os , string,spacy,nltk
from TfIdf.mainBD import insertValues
from sklearn.feature_extraction.text import TfidfVectorizer
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from nltk.stem import WordNetLemmatizer
nltk.download('stopwords')
nltk.download('punkt')
# from requests.adapters import HTTPAdapter


def read_folder_names(path_dir):
    return [item for item in os.listdir(path_dir) if os.path.isdir(os.path.join(path_dir, item))]

def read_file_SRT(path, file):
    with open(os.path.join(path, file), "r", encoding='ISO-8859-1') as f:
        lines = [line.rstrip('\n') for line in f if line[0].isalpha() or line[0] == '-' or line[0] == '.']
        subtitle = [line for line in lines if not line.strip().split()[0].isdigit()]
        subtitles = ' '.join(subtitle)
    return subtitles

def read_file_SUB(path, file):
    with open(os.path.join(path, file), "r", encoding='ISO-8859-1') as f:   
        subtitles = ""
        for line in f:
            try:
                text = line.strip().split("}", maxsplit=2)[1:]
                subtitles += text.rstrip('\n') + ' '
            except:
                pass
    return subtitles



def lemmatizing_FR(words):
    nlp = spacy.load('fr_core_news_sm')
    doc = nlp(words)
    lemmas = []
    for token in doc:
        if token.pos_ in ['VERB', 'ADJ', 'NOUN']:
            lemma = token.lemma_
            lemmas.append(lemma)
    lemmatized_text = ' '.join(lemmas)
    return lemmatized_text

def lemmatizing_EN(words):
    lemmatizer = WordNetLemmatizer()
    lemmatized_tokens = [lemmatizer.lemmatize(word) for word in nltk.word_tokenize(words)]
    lemmatized_text = ' '.join(lemmatized_tokens)
    return lemmatized_text

def Remove_WordLemmatizing(text,version):
    if version == 'VO':
        stop_words = set(stopwords.words('english'))
    if version == 'VF':
        stop_words = set(stopwords.words('french'))
        
    tab_punctuation = str.maketrans(string.punctuation, ' ' * len(string.punctuation))
    clean_text =  text.translate(tab_punctuation)
    words = word_tokenize(clean_text.lower())
    clean_words = [word for word in words if len(word) >4]
    text_clean = [mot for mot in clean_words if mot.lower() not in stop_words]
    clean_sentence = ' '.join(text_clean)
    if version == 'VO':
        textLemm=  lemmatizing_EN(clean_sentence)
    if version == 'VF':
        textLemm=  lemmatizing_FR(clean_sentence)
    return re.sub(r'\d+', '', textLemm)


def extract_subtitlesEN(path):
    folders = read_folder_names(path)
    subtitles = ""
    for folder in folders:
        for root, dirs, files in os.walk(path+'/'+folder):
            for file in files:
                if file.endswith(".sub"):
                    subtitle = read_file_SUB(root,file)
                else:
                    file.endswith(".srt") or file.endswith(".SRT")
                    subtitle= read_file_SRT(root,file)
                if subtitle:
                    subtitles += Remove_WordLemmatizing(subtitle,'VO')+' '
    return subtitles




def countTFIDFVO(path):
    series = []
    serieName = []
    dicSeries = {}
    for folderSerie in os.listdir(path):
        serieName.append(folderSerie)
        pathSerie = os.path.join(path, folderSerie)
        for folderVersion in os.listdir(pathSerie):
            pathVersion = os.path.join(pathSerie, folderVersion)
            if folderVersion == 'VO':       
                subtitles = extract_subtitlesEN(pathVersion)
                series.append(subtitles)           
    vectorizer = TfidfVectorizer()
    tfidf_matrix = vectorizer.fit_transform(series)
    features = vectorizer.get_feature_names_out()
    for i,document in enumerate(series):
        dicSeries[serieName[i]] = {}
        for j, feature in enumerate(features):
            tfidf_score = tfidf_matrix[i, j]
            if tfidf_score > 0.03:   
                dicSeries[serieName[i]][feature] = tfidf_score          
    insertValues (dicSeries,'VO')


def countTFIDFVF(path):
    series = []
    serieName = []
    dicSeries = {}

    for folderSerie in os.listdir(path):
        serieName.append(folderSerie)
        pathSerie = os.path.join(path, folderSerie)
        for folderVersion in os.listdir(pathSerie):
            pathVersion = os.path.join(pathSerie, folderVersion)
            if folderVersion == 'VF':       
                subtitles = extract_subtitlesEN(pathVersion)
                series.append(subtitles)

    vectorizer = TfidfVectorizer()
    tfidf_matrix = vectorizer.fit_transform(series)
    features = vectorizer.get_feature_names_out()
    for i ,document in enumerate(series):
        dicSeries[serieName[i]] = {}
        for j, feature in enumerate(features):
            tfidf_score = tfidf_matrix[i, j]
            if tfidf_score > 0.03:     
                dicSeries[serieName[i]][feature] = tfidf_score         
    
    insertValues (dicSeries,'VF')
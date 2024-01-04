import re, os , zipfile, shutil, py7zr

def remove_empty_folders(path):
    for root, dirs, _ in os.walk(path, topdown=False):
        for dir in dirs:
            dir_path = os.path.join(root, dir)
            try:
                os.removedirs(dir_path)
            except OSError:
                pass

def moveFolderByLevel(source_folder, destination_folder):
    for root, _, files in os.walk(source_folder):
        for file in files:
            file_path = os.path.join(root, file)
            extract_path = os.path.join(destination_folder, file)
            shutil.move(file_path, extract_path)
            remove_empty_folders(source_folder)

def unzip_folder(zip_path):
    folder_name = os.path.splitext(zip_path)[0]
    if zip_path.endswith('.zip'):
        with zipfile.ZipFile(zip_path, 'r') as zip_ref:
            pathZip = os.path.join(zip_path, folder_name)
            zip_ref.extractall(pathZip)
        moveFolderByLevel(pathZip, pathZip) 
    if zip_path.endswith('.7z'):
        with py7zr.SevenZipFile(zip_path, mode='r') as sz_ref:
            sz_ref.extractall(os.path.join(zip_path, folder_name))   
        moveFolderByLevel(pathZip, pathZip) 

def createFolderVersion(folderRoot,tabVersion):
    tab_pathVersion = []
    for version in tabVersion:
        chemin_dossier = os.path.join(folderRoot, version)
        if not os.path.exists(chemin_dossier):
            os.makedirs(chemin_dossier)
            tab_pathVersion.append(chemin_dossier)  
    return tab_pathVersion
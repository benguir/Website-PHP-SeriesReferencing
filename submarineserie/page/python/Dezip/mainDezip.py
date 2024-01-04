import re, os , zipfile, shutil
from Dezip.prepareFolders import unzip_folder, createFolderVersion
from Dezip.functionDezip import moveFolder, moveFile


def mainDezip(folderRoot,folderDesti):
    dossiers = ["VO", "VF"]
    regexVO = re.compile('^\d*\w+VO\.[^.]+$')
    regexVF = re.compile('^\d*\w+VF\.[^.]+$')

    for folderSerie in os.listdir(folderRoot):
        path = os.path.join(folderRoot, folderSerie)
        unzip_folder(path)
        os.remove( path)

    for folderSerie in os.listdir(folderRoot):
        path = os.path.join(folderRoot, folderSerie)
        tab_path = createFolderVersion(os.path.join(folderRoot, folderSerie),dossiers)  
        if os.path.isdir(path): 
            for folderData in os.listdir(path):
                path1 = os.path.join(path, folderData)
                if zipfile.is_zipfile(path1):
                    if regexVO.match(folderData):
                        moveFolder(path1,tab_path[0]) 
                    if regexVF.match(folderData):
                        moveFolder(path1,tab_path[1])
                elif os.path.isfile(path1):
                    if regexVO.match(folderData):
                        moveFile(folderRoot,tab_path[0],folderSerie,folderData) 
                    if regexVF.match(folderData):
                        moveFile(folderRoot,tab_path[1],folderSerie,folderData)
        if not os.path.exists(folderDesti+'/'+ folderSerie):  
            shutil.move(os.path.join(folderRoot, folderSerie), folderDesti)
        else:
            print('la série existe déjà')
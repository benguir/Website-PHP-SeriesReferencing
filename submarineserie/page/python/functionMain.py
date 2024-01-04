from TfIdf.mainTFIDF import mainTFIDF
from Dezip.mainDezip import mainDezip


path = "../administration/SubmarinesSeries/temp"
pathDesti = "../administration/SubmarinesSeries/sous-titres"
mainDezip(path,pathDesti)
mainTFIDF(pathDesti)
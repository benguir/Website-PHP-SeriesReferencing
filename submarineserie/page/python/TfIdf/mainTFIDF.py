from TfIdf.mainBD import keepSeries, addSeriesInBd
from TfIdf.treatmentTFIDF   import countTFIDFVO, countTFIDFVF

def mainTFIDF(path):
    series = keepSeries(path)
    print(series)
    addSeriesInBd(series)
    countTFIDFVF(path)
    countTFIDFVO(path)
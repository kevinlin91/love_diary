from gensim import corpora,models,similarities
dictionary = corpora.Dictionary.load('./tmp/dic.dict')
corpus = corpora.MmCorpus('./tmp/cor.mm')
lsi = models.LsiModel.load('./tmp/model.lsi')

doc =""
for line in open('diary.txt','r'):
 doc = doc + line


vec_bow = dictionary.doc2bow(doc.split())
vec_lsi = lsi[vec_bow]
index = similarities.MatrixSimilarity(lsi[corpus])
sims = index[vec_lsi]
sims = sorted(enumerate(sims),key=lambda item: -item[1])

f = open('recommend.txt','w')
for line in sims:
 f.write(str(line))
 f.write('\n')

f.close()

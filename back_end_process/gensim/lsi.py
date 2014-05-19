from gensim import corpora,models,similarities
documents = [""]
for i in open('termlyrics.txt','r'):
 i = i.strip('\n')
 documents.append(i)

documents.pop(0)
texts = [[word for word in document.split()] for document in documents]
dictionary = corpora.Dictionary(texts)
dictionary.save('./tmp2/dic.dict')
corpus = [dictionary.doc2bow(text) for text in texts]
corpora.MmCorpus.serialize('./tmp2/cor.mm', corpus)
tfidf = models.TfidfModel(corpus)
corpus_tfidf = tfidf[corpus]
lsi = models.LsiModel(corpus_tfidf,id2word=dictionary,num_topics=300)
lsi.save('./tmp2/model.lsi')

This is to calculate tfidf and find the keywords.

The analysis.php will calculate the tf and idf, then store them to two Folder which are tf(folder) and idf(folder).
TF folder will store the term and tf-value just like "愛情 15" for every documents.
IDF folder is the same with TF folder but the tf-value change to idf-value.

The tfidf.php will load the files in the TF folder and IDF fold, and ouput a file called tfidf.txt
In the idf.txt, there will be store every terms with the idf-value of every documents.

Finally, the keyword.php will ouput the keywords for every documents.(default is 5 keywords)

The sample input for analysis.php is like 告白.txt which is preprocessed by 中研院斷詞系統(CKIP)


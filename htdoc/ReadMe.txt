#If you want to use these program, just install xampp and put them into /xampp/htdocs
#Your computer should install python for < ver2.7, and install gensim package for python
#Gensim:http://radimrehurek.com/gensim/index.html


CKIPCient.php is to connect 中研院斷詞系統.
connectdb.php, createlovediary.php, createmember.php is to create database in phpmyadmin.
diaryshow.php is to catch the data and show in the page for 日記管理.

diary11.html is the most important page that allow user to enter their diarys, then analysis the top-3 songs and moods by post data to final.php and predict2.php
final.php and /svm/windows/predict2.php is the main function for this project.
final.php will catch the data that diary11.html post, and then find the rank of songs by calling lyric.py(do lsi).Then throw the top-3 songs back to the diary11.html.
predict2.php will the same catch the data that diary11.html post, and then classify the data.Then throw the result back to the diary11.html.


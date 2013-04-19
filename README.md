m-Bulance
========

a mobile healthcare diagnostic service created using KooKoo's PHP library

Testing Documentation
Sandbox Phone No: 040-39411020, 080-39411020, 022-39411020, 033-39411020, 044-39411020, 011-39411020, 020-39411020
Pin 1: 7063 (current working alpha version - index1.php)
Pin 2: 7135 (test beta version - index.php)

-

response.php
m-Bulance uses KooKoo's PHP library to generate XML. 

-

trees.php
binary trees to be used with the playtext (text to voice) method. KooKoo currently only supports English with their playtext command and this is what is used in the alpha version of m-Bulance
-
audio
The audio files are .wav files split up by which tree they belong to. The first digit of the file name represents which tree the sound clip belongs to.
At the moment, m-Bulance supports the following trees in Punjabi along with the digit representing the tree:
  - short term abdominal pain (1)
  - cold and flu (2)
  - cough (3)

Naming Scheme
The first digit of the file name represents which tree the sound clip belongs to and the subsequent digits represent the binary encoding of the branch, with a 1 representing traversing down the "yes" branch and 0 representing traversing down the "no" branch.

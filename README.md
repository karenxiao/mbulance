m-Bulance
========

a mobile healthcare diagnostic service created using KooKoo

-

response.php
m-Bulance uses KooKoo's PHP library to generate XML. 

-

audio
The audio files are .wav files split up by which tree they belong to. The first digit of the file name represents which tree the sound clip belongs to.
At the moment, m-Bulance supports the following trees in Punjabi along with the digit representing the tree:
  - short term abdominal pain (1)
  - cold and flu (2)
  - cough (3)

Naming Scheme
The first digit of the file name represents which tree the sound clip belongs to and the subsequent digits represent the binary encoding of the branch, with a 1 representing traversing down the "yes" branch and 0 representing traversing down the "no" branch.

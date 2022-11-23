# torn-custom-signatures
Basic Live signature creation script for Torn.
------------------------------------------------
## Prerequesites: 
* A file containing the apikeys in an array named as *FACTION_ID*-apikeys.php (api keys on the example are random , and will not work on the torn API. put your api keys (only requires public access)
* Font files that you wanna use for your text. i am using UBUNTU and PNR
* PNG background images 600x100 size named as *FACTION_ID*-1.png *FACTION_ID*-2.png etc. your member will decide which image to use by changing the link.  

## what it does 
The script chooses a random api key from the array on each image request, it then requests the user data from api. It checks if the user is a member of the faction, loads the image, imprints the text data to the image and serves the image as an output. If you use the link as an "insert image" link in torn, each time this image is to be displayed , the script will update the image with a new updated version (now has a 10seconds buffer). 

The more requests the more API keys are needed in order not to get the key "blocked" and get an empty response. for a full faction you will need around 10 keys. The more the better.

If the player does not request a certain image to be displayed, it will show the 1st one (*-1.png)

## Typical Folder / files structure example
>torn-signature.php
>
>includes/11111-apikeys.php
>
>includes/11111-1.png
>
>includes/11111-2.png
>
>includes/11111-3.png
>
>includes/UBUNTU-MEDIUM.TTF
>
>includes/PRN.ttf

The link to give you the signature with the default image is 

**test.server.com/torn-signature.php?id=PLAYERS_TORN_ID&img=IMAGE_NUMBER


#### If you do like this script, and find it useful, i accept donations in the form of IG currency at hexxeh[2428617] . 

#### If you have any questions, don't hesitate to contact me ingame by mail. 

#### If you lack the experience to mod this script and/or to host it, i can mod/host it on my servers for your faction for a price. Lets talk!

!#/bin/bash

git add --all 

git commit -am "more stuff"

git push

ssh amazon 'cd sites/likedmedia.rodderscode.co.uk && git pull'


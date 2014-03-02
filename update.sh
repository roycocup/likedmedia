#!/bin/bash

if [ -z "$@" ] 
then
    comment="more stuff" 
else
	comment="$@"
fi


git add --all 

git commit -am "$comment"

git push

ssh amazon 'cd sites/likedmedia.rodderscode.co.uk && git pull'


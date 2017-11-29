#!/bin/bash
git pull
echo "Start to pull from remote...\n"
git add .
echo "add the change file to local reposit"
git commit -m "$1"
echo "commit the change to version reposit"
git push origin master
echo "finished !"
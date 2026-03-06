#!/bin/sh
echo "$(tput setaf 0)git add . in app and resources folder"
cd app
git add .
cd ..
cd resources
git add .
cd ..
echo "git commit"
git commit -m "From Mac$1"
echo "git push $(tput sgr0)"
git push
echo "$(tput setaf 0) Completed $(tput sgr0)"

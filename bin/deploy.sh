#!/bin/bash
# Unpack secrets; -C ensures they unpack *in* the .travis directory
tar xvf .travis/secrets.tar -C .travis

# Setup SSH agent:
eval "$(ssh-agent -s)" #start the ssh agent
chmod 600 .travis/skeletor_installer.pem
ssh-add .travis/skeletor_installer.pem

# Setup git defaults:
git config --global user.email "Daniel Leech"
git config --global user.name "dainel@dantleech.com"

# Add SSH-based remote to GitHub repo:
git remote add deploy git@github.com:dantleech/skeletor.git
git fetch deploy

# Get box and build PHAR
curl -LSs https://box-project.github.io/box2/installer.php | php
./box.phar build -vv
# Without the following step, we cannot checkout the gh-pages branch due to
# file conflicts:
mv skeletor.phar skeletor.phar.tmp

# Checkout gh-pages and add PHAR file and version:
git checkout -b gh-pages deploy/gh-pages
mv skeletor.phar.tmp skeletor.phar
sha1sum skeletor.phar > skeletor.phar.version
git add skeletor.phar skeletor.phar.version

# Commit and push:
git commit -m 'Rebuilt phar'
git push deploy gh-pages:gh-pages

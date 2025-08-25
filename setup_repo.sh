#!/bin/bash

# Simple GitHub repo setup for Moodle project

REPO_NAME="moodle-careerlearning"

# Check if gh CLI is installed
if ! command -v gh &> /dev/null; then
    echo "GitHub CLI (gh) not found. Install it first:"
    echo "macOS: brew install gh"
    echo "Ubuntu: sudo apt install gh"
    exit 1
fi

# Create repo
gh repo create "$REPO_NAME" --public --add-readme

# Initialize git and push
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin "https://github.com/$(gh api user --jq .login)/$REPO_NAME.git"
git push -u origin main

echo "Repository created: https://github.com/$(gh api user --jq .login)/$REPO_NAME"

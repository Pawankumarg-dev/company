#!/bin/bash

input_file="$1"
inputnopass="$2"
output_file="$3"
password="$4"
watermark="$5"
newpassword="$6"
owner="nberit"
JAR="/var/www/html/rcinber/app/processpdf/pdfbox-app-3.0.3.jar"

# # Step 1: Decrypt
java -jar "$JAR" decrypt \
    -i="$input_file" \
    -o="$inputnopass" \
    -password="$password"

# if [ $? -ne 0 ]; then
#     echo "ERROR: Decryption failed"
#     exit 1
# fi



# Step 2: Overlay
# java -jar "$JAR" overlay \
#     -i="$inputnopass" \
#     -o="$output_file" \
#     -default="$watermark" \
#     -position=FOREGROUND
# if [ $? -ne 0 ]; then
#     echo "ERROR: Overlay failed"
#     exit 1
# fi

# Step 3: Encrypt
java -jar "$JAR" encrypt \
    -i="$inputnopass" \
    -o="$output_file" \
    -O="$nberit" \
    -U="$newpassword" \
    -canExtractContent=false

    
# temp_file="${output_file%.pdf}_temp.pdf"

# java -jar "$JAR" encrypt \
#     -i="$output_file" \
#     -o="$temp_file" \
#     -O="$owner" \
#     -U="$newpassword" \
#     -keyLength 256 \
#     -canPrint \
#     -canExtractContent=false \
#     -canModify=false \
#     -canModifyAnnotations=false \
#     -canFillInForm=false \
#     -canAssemble=false \
#     -canExtractForAccessibility=false

if [ $? -ne 0 ]; then
    echo "ERROR: Encryption failed"
    exit 1
fi

# Replace original file safely
# mv "$temp_file" "$output_file"


# java -jar "$JAR" export:images \
#     -i "$output_file" \
#     -prefix /var/www/html/rcinber/public/files/watermark/page \
#     -format png \
#     -dpi 400

echo "SUCCESS"
exit 0
#!/bin/bash

input_file="$1"
output_file="$2"
password="$3"

JAR="/var/www/html/rcinber/app/processpdf/pdfbox-app-3.0.3.jar"

# Check input file exists
if [ ! -f "$input_file" ]; then
    echo "ERROR: Input file not found"
    exit 1
fi

# Ensure output directory exists
mkdir -p "$(dirname "$output_file")"

# Decrypt
java -jar "$JAR" decrypt \
    -i="$input_file" \
    -o="$output_file" \
    -password="$password"

if [ $? -ne 0 ]; then
    echo "ERROR: Decryption failed"
    exit 1
fi

echo "SUCCESS: File decrypted"
exit 0
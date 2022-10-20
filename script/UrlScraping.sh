#! /bin/bash

# internal-external-links-lists.sh
# Script to list all internal & external links with sources, destinations & anchors.
# Originally written by Armand Philippot <contact@armandphilippot.com>.


# run this script : sh UrlScraping.sh
###############################################################################
#
# MIT License

# Copyright (c) 2020 Armand Philippot

# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the "Software"), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:

# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.

# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
# SOFTWARE.
#
###############################################################################

echo -e "Ce script permet de générer une liste des liens internes et externes avec la source, la destination et l'ancre.\n"

# We ask for the website to crawl
read -rp "Saisir l'URL du site: " _site_url

# We create a spinner
# Thanks to Louis Marascio - http://fitnr.com/showing-a-bash-spinner.html
spinner() {
    local pid=$!
    local delay=0.75
    local spinstr='|/-\'
    while [ "$(ps a | awk '{print $1}' | grep $pid)" ]; do
        local temp=${spinstr#?}
        printf " [%c]  " "$spinstr"
        local spinstr=$temp${spinstr%"$temp"}
        sleep $delay
        printf "\b\b\b\b\b\b"
    done
    printf "    \b\b\b\b"
}

# We display a warning message.
echo -e "Nous parcourons le site pour récupérer la liste d'URL. Cela peut prendre du temps, d'autant plus si votre site en comporte beaucoup.\n"
echo -e "Veuillez patienter.\n"

# We store the output of wget (urls list) in a temporary text file.
wget --spider --no-check-certificate --force-html -nd --delete-after -r -l 0 "$_site_url" 2>&1 | grep '^--' | awk '{ print $3 }' | grep -v '\.\(css\|js\|png\|gif\|jpg\|ico\|webmanifest\|svg\|pdf\|txt\)$' | grep -v '\/feed\/\|selectpod\.php\|xmlrpc\.php\|matomo-proxy\.php' | sort | uniq >internal-external-links-list.txt &
spinner

# We define a separator for our CSV file.
_sep="§"

# We create our CSV files and write headers.
echo "Source${_sep}Destination${_sep}Ancre" >internal-links-list.csv
echo "Source${_sep}Destination${_sep}Ancre" >external-links-list.csv

# We display a warning message.
echo -e "Nous traitons les URLs. Cela peut prendre du temps.\n"
echo -e "Veuillez patienter."

# We read each entry, we extract links and we write values in CSV files.
while read -r _url; do
    _url_list_with_anchor="$(curl -s "$_url" | grep -o '<a .*href=.*>.*</a>' | grep -v '\.\(css\|js\|png\|gif\|jpg\|ico\|webmanifest\|svg\|pdf\|txt\)' | sed -e 's/<a/\n<a/g' | perl -pe 's/(.*?)<a .*?href=['"'"'"]([^'"'"'"]{1,})['"'"'"][^>]*?>(?:<[^>]*>){0,}([^<]*)(?:<.*>){0,}<\/a>(.*?)$/\2'"$_sep"'\3/g' | sed -e '/^$/ d')"

    # We read only internal links and we write the source and destination in CSV file.
    _int_links="$(echo "$_url_list_with_anchor" | grep -E "(${_site_url%/}|^[/#])")"
    while read -r _internal; do
        echo "${_url}${_sep}${_internal}"
    done <<<"${_int_links}" >>internal-links-list.csv &
    spinner

    # We read only external links and we write the source and destination in CSV file.
    _ext_links="$(echo "$_url_list_with_anchor" | grep -Ev "(${_site_url%/}|^[/#])")"
    while read -r _external; do
        echo "${_url}${_sep}${_external}"
    done <<<"${_ext_links}" >>external-links-list.csv &
    spinner
done <internal-external-links-list.txt &
spinner

# We delete our temporary file internal-external-links-list.txt
rm internal-external-links-list.txt

# End.
echo -e "Les fichiers internal-links-list.csv et external-links-list.csv ont été générés. Le script est terminé."
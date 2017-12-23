#!/bin/bash

VERSION=$(curl -s https://api.wordpress.org/core/version-check/1.7/ | jq '.offers[0].current' | tr -d \")
WPFILE="wordpress-${VERSION}-sv_SE.tar.gz"

echo "Downloading WP - ${WPFILE}"
curl -s -O https://sv.wordpress.org/${WPFILE}
echo "Extracting WP"
tar xzf $WPFILE --overwrite -C docker-wp/.
echo "Clean up"
rm ${WPFILE}

echo "Copy plugin"
cp -r ponty-connector docker-wp/wordpress/wp-content/plugins/ponty-connector

echo "Done"

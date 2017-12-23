#!/bin/bash

POT="lang/messages.pot"
LANGS="en_US sv_SE"
SOURCES="*.php"

# Create template
echo "Creating POT"
rm -f $POT
find . -iname '*.php'| xargs xgettext \
    --copyright-holder="2014 Ponty" \
    --package-name="Ponty Connector" \
    --package-version="1.0" \
    --language=PHP \
    --sort-output \
    --keyword=__ \
    --keyword=_e \
    --from-code=UTF-8 \
    --output=$POT \
    --default-domain=pnty \
    -D .
    #$SOURCES

# Create languages
for LANG in $LANGS
do
    if [ ! -e "lang/pnty-$LANG.po" ]
    then
        echo "Creating language file for $LANG"
        msginit --no-translator --locale=$LANG.UTF-8 --output-file=lang/pnty-$LANG.po --input=$POT
    fi

    echo "Updating language file for $LANG from $POT"
    msgmerge --sort-output --update --backup=off lang/pnty-$LANG.po $POT

    echo "Converting $LANG.po to $LANG.mo"
    msgfmt --check --verbose --output-file=lang/pnty-$LANG.mo lang/pnty-$LANG.po
done

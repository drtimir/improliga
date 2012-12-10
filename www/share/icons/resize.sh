#!/bin/bash

root="$( cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
themes="${root}/*"

for theme in $themes; do
	if [ -d "${theme}" ]; then
		files=`find "${theme}/32" -type f -name "*.png"`
		mkdir "${theme}/24" 2> /dev/null
		mkdir "${theme}/16" 2> /dev/null

		for file in $files; do
			bname=`basename ${file}`
			dirname=`basename \`dirname ${file}\``

			mkdir "${theme}/24/${dirname}" 2> /dev/null
			mkdir "${theme}/16/${dirname}" 2> /dev/null

			convert "${file}" -resize 24x24 "${theme}/24/${dirname}/${bname}"
			convert "${file}" -resize 16x16 "${theme}/16/${dirname}/${bname}"
		done
	fi
done

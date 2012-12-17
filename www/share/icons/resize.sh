#!/bin/bash

root="$( cd -P "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
themes="${root}/*"
size_source="32"
sizes="32 24 16"

for theme in $themes; do
	if [ -d "${theme}" ]; then
		files=`find "${theme}/${size_source}" -type f -name "*.png"`

		for size in $sizes; do
			mkdir "${theme}/${size}" 2> /dev/null

			for file in $files; do
				bname=`basename ${file}`
				dirname=`basename \`dirname ${file}\``

				if [[ "${dirname}" == "${size_source}" ]]; then
					dirname=""
				else
					mkdir "${theme}/${size}/${dirname}" 2> /dev/null
				fi

				convert "${file}" -resize "${size}x${size}" "${theme}/${size}/${dirname}/${bname}"
			done
		done
	fi
done

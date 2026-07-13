#!/bin/bash
HERE="$(cd "$(dirname "$0")" && pwd)"
"$HERE/toggle-bcmc.sh" enable "$@"
echo
read -r -p "Нажмите Enter, чтобы закрыть окно..."

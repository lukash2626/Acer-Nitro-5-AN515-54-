#!/bin/bash
HERE="$(cd "$(dirname "$0")" && pwd)"
"$HERE/toggle-bcmc.sh" disable "$@"
echo
read -r -p "Нажмите Enter, чтобы закрыть окно..."

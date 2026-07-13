#!/bin/bash
set -euo pipefail
CONFIG="${1:-}"
if [[ -z "$CONFIG" ]]; then
  for candidate in /Volumes/*/EFI/OC/config.plist; do
    if [[ -f "$candidate" ]]; then CONFIG="$candidate"; break; fi
  done
fi
if [[ -z "$CONFIG" || ! -f "$CONFIG" ]]; then
  echo "EFI/config.plist не найден. Сначала смонтируйте EFI-раздел."
  read -r -p "Нажмите Enter, чтобы закрыть окно..."; exit 1
fi
PB=/usr/libexec/PlistBuddy
BACKUP="${CONFIG}.before-tahoe-$(date +%Y%m%d-%H%M%S)"
cp "$CONFIG" "$BACKUP"
FOUND=0
for ((i=0; i<100; i++)); do
  bundle="$($PB -c "Print :Kernel:Add:$i:BundlePath" "$CONFIG" 2>/dev/null || true)"
  case "$bundle" in
    AppleBCMWLANCompanion.kext|WhateverGreen.kext)
      $PB -c "Set :Kernel:Add:$i:Enabled false" "$CONFIG"
      echo "$bundle отключён для установки Tahoe."
      FOUND=$((FOUND+1));;
  esac
done
if [[ "$FOUND" -ne 2 ]]; then
  echo "Предупреждение: найдено драйверов: $FOUND из 2. Проверьте config.plist вручную."
fi
echo "Резервная копия: $BACKUP"
echo "Перезагрузитесь, выполните Reset NVRAM и снова запустите обновление."
read -r -p "Нажмите Enter, чтобы закрыть окно..."

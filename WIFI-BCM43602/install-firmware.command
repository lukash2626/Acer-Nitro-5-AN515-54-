#!/bin/bash
set -euo pipefail
HERE="$(cd "$(dirname "$0")" && pwd)"
FIRMWARE="brcmfmac43602-pcie_7.35.177.61.bin"
EXPECTED="bf4cfc23ee952a3d82ef33a0f5f87853201c98f1bed034876a910f354f37862d"
ACTUAL="$(shasum -a 256 "$HERE/$FIRMWARE" | awk '{print $1}')"
if [ "$ACTUAL" != "$EXPECTED" ]; then
  echo "Ошибка: контрольная сумма прошивки не совпадает."
  exit 1
fi
sudo mkdir -p /usr/local/share/firmware/wifi
sudo cp "$HERE/$FIRMWARE" /usr/local/share/firmware/wifi/
sudo chmod 644 "/usr/local/share/firmware/wifi/$FIRMWARE"
echo "Прошивка BCM43602 установлена. Теперь перезагрузитесь с новой EFI."

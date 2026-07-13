#!/bin/bash
set -euo pipefail

MODE="${1:-}"
CONFIG="${2:-}"

if [[ "$MODE" != "enable" && "$MODE" != "disable" ]]; then
  echo "Использование: $0 enable|disable [/путь/к/EFI/OC/config.plist]"
  exit 2
fi

if [[ -z "$CONFIG" ]]; then
  for candidate in /Volumes/*/EFI/OC/config.plist; do
    if [[ -f "$candidate" ]]; then CONFIG="$candidate"; break; fi
  done
fi

if [[ -z "$CONFIG" || ! -f "$CONFIG" ]]; then
  echo "EFI/config.plist не найден. Сначала смонтируйте EFI-раздел."
  echo "Затем запустите команду ещё раз или передайте путь к config.plist вторым аргументом."
  exit 1
fi

PLISTBUDDY=/usr/libexec/PlistBuddy
INDEX=""
for ((i=0; i<100; i++)); do
  bundle="$($PLISTBUDDY -c "Print :Kernel:Add:$i:BundlePath" "$CONFIG" 2>/dev/null || true)"
  if [[ "$bundle" == "AppleBCMWLANCompanion.kext" ]]; then INDEX="$i"; break; fi
done

if [[ -z "$INDEX" ]]; then
  echo "AppleBCMWLANCompanion.kext не найден в Kernel -> Add."
  exit 1
fi

BACKUP="${CONFIG}.backup-$(date +%Y%m%d-%H%M%S)"
cp "$CONFIG" "$BACKUP"
if [[ "$MODE" == "disable" ]]; then VALUE=false; WORD="отключён"; else VALUE=true; WORD="включён"; fi
$PLISTBUDDY -c "Set :Kernel:Add:$INDEX:Enabled $VALUE" "$CONFIG"

RESULT="$($PLISTBUDDY -c "Print :Kernel:Add:$INDEX:Enabled" "$CONFIG")"
echo "AppleBCMWLANCompanion $WORD (Enabled=$RESULT)."
echo "Резервная копия: $BACKUP"
echo "Теперь перезагрузите компьютер."

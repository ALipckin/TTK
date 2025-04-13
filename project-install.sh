git config core.fileMode false
(
  cd ./backend-api/ || exit
  ./install.sh
) &
(
  cd ./frontend-nextjs/ || exit
  ./nextjs-install.sh
) &

wait
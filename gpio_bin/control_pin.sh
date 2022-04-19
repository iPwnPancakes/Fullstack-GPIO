# cat > php_shell.sh <<CONTENT
  #!/bin/sh
  sudo ./target/debug/vacuum $1 $2

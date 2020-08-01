#!/bin/bash
set -e

# Sendy docker entrypoint to ensure environment and secrets are initalized.
# Adopted from mysql docker docker-entrypoint.sh
# https://github.com/docker-library/mysql/blob/master/5.6/docker-entrypoint.sh

# logging functions
write_log() {
  local type="$1"; shift
  printf '%s [%s] [Entrypoint]: %s\n' "$(date --rfc-3339=seconds)" "$type" "$*"
}
log_info() {
  write_log Info "$@"
}
log_warn() {
  write_log Warn "$@" >&2
}
log_error() {
  write_log ERROR "$@" >&2
  exit 1
}

# usage: file_env VAR [DEFAULT]
#    ie: file_env 'XYZ_DB_PASSWORD' 'example'
# (will allow for "$XYZ_DB_PASSWORD_FILE" to fill in the value of
#  "$XYZ_DB_PASSWORD" from a file, especially for Docker's secrets feature)
file_env() {
  local var="$1"
  local fileVar="${var}_FILE"
  local def="${2:-}"
  if [ "${!var:-}" ] && [ "${!fileVar:-}" ]; then
    log_error "Both $var and $fileVar are set (but are exclusive)"
  fi
  local val="$def"
  if [ "${!var:-}" ]; then
    val="${!var}"
  elif [ "${!fileVar:-}" ]; then
    val="$(< "${!fileVar}")"
  fi
  export "$var"="$val"
  unset "$fileVar"
}

# check to see if this file is being run or sourced from another script
_is_sourced() {
  # https://unix.stackexchange.com/a/215279
  [ "${#FUNCNAME[@]}" -ge 2 ] \
    && [ "${FUNCNAME[0]}" = '_is_sourced' ] \
    && [ "${FUNCNAME[1]}" = 'source' ]
}

# Intialized environment variables for docker execution
# This should be called after apache2_check_config, but before any other functions
docker_setup_env() {
  log_info "Initializing environment variables..."
  # Initialize values that might be stored in a file
  file_env 'SENDY_PROTOCOL' 'http'
  file_env 'SENDY_FQDN'
  file_env 'MYSQL_HOST'
  file_env 'MYSQL_DATABASE' 'sendy'
  file_env 'MYSQL_USER' 'sendy'
  file_env 'MYSQL_PASSWORD'
}

# Verify that the minimally required password settings are set for new databases.
docker_verify_minimum_env() {
  if [[ -z "$SENDY_FQDN" || -z "$MYSQL_HOST" || -z "$MYSQL_PASSWORD" ]]; then
    log_error $'Environment variables not initialized!!\n\tYou must to specify MYSQL_HOST and MYSQL_PASSWORD'
  fi
}

apache2_check_config() {
  local toRun=( "$@" -t ) errors
  if ! errors="$("${toRun[@]}" 2>&1 >/dev/null)"; then
    log_error $'Apache2 failed while attempting to check config\n\tcommand was: '"${toRun[*]}"$'\n\t'"$errors"
  else
    log_info "Apache2 runtime configurations: OK"
  fi
}

_apache2_want_help() {
  local arg
  for arg; do
    case "$arg" in 
      -'?'|-h|-v|-V|-l|-L|-t|-S|-M)
        return 0
        ;;
    esac
  done
  return 1
}

_main() {
  log_info "Entrypoint script for Sendy Server ${SENDY_VERSION} started."

  # if command starts with an option, prepend php
  if [ "${1:0:1}" = '-' ]; then
    log_info "Command-line option found.  Appending 'php'. "
    set -- php "$@"
  fi

  # skip setup if we are not running apache2
  if [ "$1" = 'apache2-foreground' ] && ! _apache2_want_help "$@"; then
    # Ensure apache config syntax is correct.
    apache2_check_config "$@"
    # Load various environment variables
    docker_setup_env "$@"
    docker_verify_minimum_env
    log_info "Let's kick the tires and light the fires!"
    log_info "Starting Apache2"
    # Start cron
    cron -f &
    log_info "Starting cron"
    exec "$@"
  else
    log_info "Comamnd-line override.  Executing: $@"
    exec "$@"
  fi
}

# If we are sourced from elsewhere, don't perform any further actions
if ! _is_sourced; then
  _main "$@"
else
  log_warn "SOURCED from another file. Entrypoint script not executed."
fi

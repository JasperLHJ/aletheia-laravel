#!/usr/bin/env bash
# Bootstrap an Ubuntu 22.04/24.04 EC2 host for Docker + this Laravel stack.
# Run on the instance after SSH (recommended: clone repo, then):
#   chmod +x scripts/setup-ec2-ubuntu.sh && ./scripts/setup-ec2-ubuntu.sh
# Or save the script to a file and: sudo bash setup-ec2-ubuntu.sh [--with-ufw]
# (Do not pipe to plain `bash` without sudo; the script will sudo-re-exec only if $0 is the script path.)
#
# Options:
#   --with-ufw     Allow OpenSSH, 80, 443 and enable UFW (ensure SG allows SSH first).
#   --skip-upgrade Only apt-get update; skip full dist-upgrade (faster).
#   --skip-docker-test  Do not run hello-world (offline / air-gapped hosts).

set -euo pipefail

WITH_UFW=false
SKIP_UPGRADE=false
SKIP_DOCKER_TEST=false

usage() {
    sed -n '1,20p' "$0" | tail -n +2
    exit 0
}

if [[ "${EUID:-}" -ne 0 ]]; then
    exec sudo -E bash "$0" "$@"
fi

while [[ $# -gt 0 ]]; do
    case "$1" in
        --with-ufw) WITH_UFW=true ;;
        --skip-upgrade) SKIP_UPGRADE=true ;;
        --skip-docker-test) SKIP_DOCKER_TEST=true ;;
        -h | --help) usage ;;
        *)
            echo "Unknown option: $1" >&2
            exit 1
            ;;
    esac
    shift
done

DEPLOY_USER="${SUDO_USER:-}"
if [[ -z "$DEPLOY_USER" || "$DEPLOY_USER" == "root" ]]; then
    DEPLOY_USER="ubuntu"
fi

if ! grep -qi ubuntu /etc/os-release 2>/dev/null; then
    echo "Warning: This script targets Ubuntu. /etc/os-release:" >&2
    cat /etc/os-release >&2 || true
fi

export DEBIAN_FRONTEND=noninteractive

echo "==> apt-get update"
apt-get update -y

if [[ "$SKIP_UPGRADE" != true ]]; then
    echo "==> apt-get upgrade (set --skip-upgrade to skip)"
    apt-get upgrade -y
fi

echo "==> Install base packages"
apt-get install -y ca-certificates curl git

if [[ "$WITH_UFW" == true ]]; then
    echo "==> Configure UFW"
    apt-get install -y ufw
    ufw allow OpenSSH
    ufw allow 80/tcp
    ufw allow 443/tcp
    ufw --force enable
    ufw status verbose || true
fi

echo "==> Add Docker apt repository"
install -m 0755 -d /etc/apt/keyrings
if [[ ! -f /etc/apt/keyrings/docker.asc ]]; then
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
    chmod a+r /etc/apt/keyrings/docker.asc
fi

# shellcheck source=/dev/null
. /etc/os-release
CODENAME="${VERSION_CODENAME:-}"
if [[ -z "$CODENAME" ]]; then
    echo "Could not read VERSION_CODENAME from /etc/os-release" >&2
    exit 1
fi

ARCH="$(dpkg --print-architecture)"
echo "deb [arch=${ARCH} signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu ${CODENAME} stable" \
    > /etc/apt/sources.list.d/docker.list

echo "==> Install Docker Engine + Compose plugin"
apt-get update -y
apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

echo "==> Enable and start Docker"
systemctl enable docker
systemctl start docker

if [[ "$SKIP_DOCKER_TEST" != true ]]; then
    echo "==> Verify Docker (hello-world)"
    docker run --rm hello-world
fi

echo "==> docker compose version"
docker compose version

if id "$DEPLOY_USER" &>/dev/null; then
    echo "==> Add user '$DEPLOY_USER' to group docker"
    usermod -aG docker "$DEPLOY_USER"
else
    echo "User '$DEPLOY_USER' not found; skip usermod docker group." >&2
fi

echo ""
echo "Done. Next steps:"
echo "  1. Log out and SSH back in so the docker group applies (or: newgrp docker)."
echo "  2. Clone this app, copy .env, then: docker compose build && docker compose up -d"
echo "  3. See docs/EC2_INSTANCE_SETUP.md and docs/EC2_DEPLOY.md"

# PHP2Shell — CVE-2026-109618 / CVE-2026-109619

Reproduction of the PHP2Shell OOM-bailout RCE chain on a pinned, isolated
`php:8.4.26-apache` (mod_php) target. Authorized lab use only — the PoC
executes a shell command on the target.

**Full technical writeup: [`report/PHP2Shell-Writeup.md`](report/PHP2Shell-Writeup.md)**

## Contents

| Path | What |
|---|---|
| `report/` | Detailed writeup + screenshots |
| `exploit/php2shell_poc.py` | Working Python PoC (fork of SAHMSEC's reference impl) |
| `lab/` | Isolated Docker lab (`compose.yaml`, `php-lab.ini`, `apache-lab.conf`, site) |
| `evidence/` | Raw logs, PoC stdout, proof file, HTTP response |
| `NOTICE.md` | Attribution |

## Quick start

Requires Docker, Docker Compose, Python 3.10+.

```bash
cd lab
docker compose up -d
docker compose exec target apache2ctl -M | grep php     # expect: php_module (shared)
curl -sS -o /dev/null -w '%{http_code}\n' http://127.0.0.1:8088/   # expect: 200

cd ../exploit
python3 php2shell_poc.py --target http://127.0.0.1:8088/

curl -sS http://127.0.0.1:8088/uploads/p.php            # executed proof page
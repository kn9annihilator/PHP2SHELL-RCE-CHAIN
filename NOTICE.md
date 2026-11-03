# Attribution

`sahmsec_poc.py`, the website, and the launchers were written for this SAHMSEC
classroom lab. The exploit flow and image calibration were reimplemented with
technical reference to the public PoC by eness at commit
`df8b16fe69ab7218f496b5d88127253fc90ff92e`:
[upstream repository](https://github.com/eness/php2shell-CVE-2026-109618-CVE-2026-109619-PoC).

Credit for the original vulnerability research and exploit technique remains
with the upstream author. The SAHMSEC implementation runs a fixed
`cp /a /u/p.php` proof command; the target is supplied with `--target` and must
be a system you are authorized to test.

# Ponty Connector

As an end user you are most likely best served by visiting [this site](https://ponty-tech.github.io/connector).

## Local test data

A very reduced test ad exists in `dummy-ad.json`. It can be used to test the Connector API with
this cURL command.

```
curl -XPOST \
  -d@dummy-ad.json \
  -H "x-pnty-auth-2: Bearer $(npx jwtgen -a HS256 -h -s pontyconnector -e 60)" \
  'http://localhost:8787/pnty_jobs_api'
```

FROM armhf/debian:jessie
MAINTAINER Sasyan Valentin <https://github.com/VSasyan>

# Installation of NodeJS
RUN apt-get update && \
    apt-get -y install nodejs && \
    apt-get autoremove && apt-get clean

COPY app.js app.js
COPY node_modules node_modules

CMD ["nodejs", "app.js"]

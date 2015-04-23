#!/bin/bash
echo "camloop called"
sudo raspivid -o - -t 0 -hf -vf -w 600 -h 400 -fps 25| cvlc -vvv stream:///dev/stdin --sout '#standard{access=http,mux=ts,dst=:8160}' :demux=h264

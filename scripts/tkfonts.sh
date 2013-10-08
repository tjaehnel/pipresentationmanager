#!/bin/sh
export DISPLAY=:0
xhost +localhost
python << EOF
import Tkinter as tk
import tkFont

tk.Tk()
fontFamilies = tkFont.families()
for crntFamily in fontFamilies:
	print crntFamily
EOF

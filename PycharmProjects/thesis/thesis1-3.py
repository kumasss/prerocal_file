#coding: UTF-8
import numpy as np
from matplotlib import pyplot as plt
import pandas as pd
from scipy.optimize import leastsq

#自由度調整済み決定係数
book = pd.read_csv('test.csv')
t = book["time"]
y = book["con"]

print(t)
print(y)

#C=(Q_in/k)*(1-exp(-kt))+C_0*exp(-kt)

p=[0.119893813,0.00225315209,340.340368]#Q_in,k,C_0

def f(t):
    f=(p[0]/p[1])*(1.0-np.exp(-p[1]*t))+p[2]*np.exp(-p[1]*t)
    return f

def res_f(f, y):
    r = y - f
    return r

t = np.array(t)
y = np.array(y)
fs = np.array(list(map(f, t)))

avg_y = np.average(y)
avg_y = y - avg_y
fs = y - fs

top = np.sum(fs * fs)/26
under = np.sum(avg_y * avg_y)/27


R2 = 1- top / under
print(R2)

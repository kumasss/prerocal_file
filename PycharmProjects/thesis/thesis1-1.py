#coding: UTF-8
import numpy as np
from matplotlib import pyplot as plt
import pandas as pd
from scipy.optimize import leastsq

book = pd.read_csv('test.csv')
t = book["time"]
y = book["con"]
logy=np.log(y)

#C=(Q_in/k)*(1-exp(-kt))+C_0*exp(-kt)

p=[0.1,0.1,240]#Q_in,k,C_0
def f(p,t):
    f=(p[0]/p[1])*(1.0-np.exp(-p[1]*t))+p[2]*np.exp(-p[1]*t)
    return f

def res_f(p,t,y):
    r = y - f(p,t)
    return r

for i in range(100):
    p1, flag = leastsq(res_f, p, args=( t, y )) #leastsq: 与えた関数の2乗の和を最小化,2乗の和であるので符号がキャンセル
    p = p1
    print(p)
    if str(p[0]) == str(float("nan")):
        break

tt=np.arange(0.1,5000.0,0.1)
a=f(p,t)
df = pd.DataFrame(a)
df.to_excel("1tests.xlsx")
b=y-f(p,t)
dh = pd.DataFrame(b)
dh.to_excel("2tests2.xlsx")

plt.plot(tt, f(p, tt), "-", color="black", linewidth=1.5, label="MODEL")
plt.plot(t, y, 'o', color="r", markersize=8, label="DATA")
plt.legend(numpoints=1, fontsize=18, loc="best")
#plt.yscale("log")
plt.xlabel("Time[days]",fontsize=18)
plt.ylabel("Concentration[Bq/m^3]",fontsize=18)
plt.xlim([0,5000])
plt.ylim([10,350])
plt.savefig("thesis1-1.eps")
plt.show()
#coding: UTF-8
import numpy as np
from matplotlib import pyplot as plt
import pandas as pd
from scipy.optimize import leastsq

book = pd.read_csv('test.csv')
t = book["time"]
y = book["con"]
logy = np.log(y)

print(t)
print(y)

p=[0.1,0.002,300,0.004,0.0005]#Q_in,k,C_0,k1,k2
def f(p,t):
    f=(p[0]/(p[3]-9.0*p[4]+p[1]))*(1.0-np.exp(-(p[3]-9.0*p[4]+p[1])*t))+p[2]*np.exp(-(p[3]-9.0*p[4]+p[1])*t)
    return f

def res_f(p,t,logy):
    r = logy - f(p,t)
    return r

for i in range(5):
    p1, flag = leastsq(res_f, p, args=(t,logy)) #leastsq: 与えた関数の2乗の和を最小化,2乗の和であるので符号がキャンセル
    p = p1
    print(p)
    if str(p[0]) == str(float("nan")):
        break


#実測値とグラフの残差
tt=np.arange(0.1,5000.0,0.1)
a=f(p,t)
df = pd.DataFrame(a)
df.to_excel("tests.xlsx")
b=logy-f(p,t)
dh = pd.DataFrame(b)
dh.to_excel("tests2.xlsx")


plt.plot(tt, f(p, tt), "-", color="black", linewidth=1.5, label="MODEL")
plt.plot(t, y, 'o', color="k", markersize=8, label="DATA")
plt.legend(numpoints=1, fontsize=18, loc="best")
#plt.yscale("log")
plt.xlabel("Time[days]",fontsize=18)
plt.ylabel("Concentration[Bq/m^3]",fontsize=18)
plt.xlim([0,5000])
plt.ylim([10,350])
plt.show()
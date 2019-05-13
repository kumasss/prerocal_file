#coding: UTF-8
import numpy as np
from matplotlib import pyplot as plt
import pandas as pd
from scipy.optimize import leastsq

book = pd.read_csv('test.csv')
t = book["time"]
y = book["con"]
logy=np.log(y)
sqrty=np.sqrt(y)

print(t)
print(y)

#C=(Q_in/k)+( ( -2*np.exp((1/2 *(-k-k1-k2)+1/2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2*(k+k1-k2-np.sqrt(-4*k*k2+(k+k1+k2)**2) ) + 2*np.exp((1/2 *(-k-k1-k2)-1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2*(k+k1-k2+np.sqrt(-4*k*k2+(k+k1+k2)**2) ) )(C_0-Q_in/k) )/(4*k2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )+( (-4*np.exp((1/2 *(-k-k1-k2) -1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2**2 + 4*np.exp((1/2 *(-k-k1-k2)+1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2**2 ) ( C泥_0 - (k1*Q_in)/(k*k2) ) )/(4*k2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )

p=[0.01,-0.01,0.01,0.01,240,240]#k,k1,k2,Q_in,C_0,C泥_0

def f(p,t):
    f=(p[3]/p[0])+((-2*np.exp((1/2*(-p[0]-p[1]-p[2])+1/2*np.sqrt(-4*p[0]*p[2]+(p[0]+p[1]+p[2])**2))*t)*p[2]*(p[0]+p[1]-p[2]-np.sqrt(-4*p[0]*p[2]+(p[0]+p[1]+p[2])**2))+2*np.exp((1/2*(-p[0]-p[1]-p[2])-1/2*np.sqrt(-4*p[0]*p[2]+(p[0]+p[1]+p[2])**2))*t)*p[2]*(p[0]+p[1]-p[2]+np.sqrt(-4*p[0]*p[2]+(p[0]+p[1]+p[2])**2)))(p[4]-p[3]/p[0]))/(4*p[2]*np.sqrt(-4*p[0]*p[2]+(p[0]+p[1]+p[2])**2))+((-4*np.exp((1/2*(-p[0]-p[1]-p[2]) -1/2*np.sqrt(-4*p[0]*p[2]+(p[0]+p[1]+p[2])**2))*t)*p[2]**2 +4*np.exp((1/2*(-p[0]-p[1]-p[2])+1/2*np.sqrt(-4*p[0]*p[2]+(p[0]+p[1]+p[2])**2))*t)*p[2]**2)*(p[5]-(p[1]*p[3])/(p[0]*p[2])))/(4*p[2]*np.sqrt(-4*p[0]*p[2]+(p[0]+p[1]+p[2])**2) )
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
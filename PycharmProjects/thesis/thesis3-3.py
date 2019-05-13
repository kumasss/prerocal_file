#coding: UTF-8
import numpy as np
from matplotlib import pyplot as plt
import pandas as pd
from scipy.optimize import leastsq

#決定係数
book = pd.read_csv('test.csv')  #データを読み込む
t = book["time"]  #時間データ
y = book["con"]  #濃度データ

# C=(Q_in/k)+( ( -2*np.exp((1/2 *(-k-k1-k2)+1/2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2*(k+k1-k2-np.sqrt(-4*k*k2+(k+k1+k2)**2) ) + 2*np.exp((1/2 *(-k-k1-k2)-1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2*(k+k1-k2+np.sqrt(-4*k*k2+(k+k1+k2)**2) ) )*(C_0-Q_in/k) )/(4*k2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )+( (-4*np.exp((1/2 *(-k-k1-k2) -1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2**2 + 4*np.exp((1/2 *(-k-k1-k2)+1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2**2 ) ( C泥_0 - (k1*Q_in)/(k*k2) ) )/(4*k2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )

p = [0.00216226, 0, 0.0318413, 0.111561, 332.804, 0]  # k,k1,k2,Q_in,C_0,C泥_0 (フィッティングの結果得られた値)

def f(t):  #モデル式2
    a1 = (p[3] / p[0])
    a2 = ((-2 * np.exp(
        (1 / 2 * (-p[0] - p[1] - p[2]) + 1 / 2 * np.sqrt(-4 * p[0] * p[2] + (p[0] + p[1] + p[2]) ** 2)) * t) * p[2] * (
                   p[0] + p[1] - p[2] - np.sqrt(-4 * p[0] * p[2] + (p[0] + p[1] + p[2]) ** 2)) + 2 * np.exp(
        (1 / 2 * (-p[0] - p[1] - p[2]) - 1 / 2 * np.sqrt(-4 * p[0] * p[2] + (p[0] + p[1] + p[2]) ** 2)) * t) * p[2] * (
                   p[0] + p[1] - p[2] + np.sqrt(-4 * p[0] * p[2] + (p[0] + p[1] + p[2]) ** 2))) * (
                  p[4] - p[3] / p[0])) / (4 * p[2] * np.sqrt(-4 * p[0] * p[2] + (p[0] + p[1] + p[2]) ** 2))
    a3 = ((-4 * np.exp(
        (1 / 2 * (-p[0] - p[1] - p[2]) - 1 / 2 * np.sqrt(-4 * p[0] * p[2] + (p[0] + p[1] + p[2]) ** 2)) * t) * p[
               2] ** 2 + 4 * np.exp(
        (1 / 2 * (-p[0] - p[1] - p[2]) + 1 / 2 * np.sqrt(-4 * p[0] * p[2] + (p[0] + p[1] + p[2]) ** 2)) * t) * p[
               2] ** 2) * (p[5] - (p[1] * p[3]) / (
            p[0] * p[2]))) / (4 * p[2] * np.sqrt(-4 * p[0] * p[2] + (p[0] + p[1] + p[2]) ** 2))

    return a1 + a2 + a3

def res_f(f, y):  #予測値と実測値の残差
    r = y - f
    return r

t = np.array(t)
y = np.array(y)
fs = np.array(list(map(f, t)))

avg_y = np.average(y)  #データ全体の平均値
y = y - avg_y  #実データとデータ全体の平均値の差
fs = fs - avg_y  #予測値とデータ全体の平均値の差
R2 = np.sum(fs * fs) / np.sum(y * y)  #決定係数
print(R2)

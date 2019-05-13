#coding: UTF-8
import numpy as np
from matplotlib import pyplot as plt
import pandas as pd
from scipy.optimize import leastsq

#自由度調整済み決定係数
book = pd.read_csv('test.csv')
t = book["time"]
y = book["con"]

# C=(Q_in/k)+( ( -2*np.exp((1/2 *(-k-k1-k2)+1/2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2*(k+k1-k2-np.sqrt(-4*k*k2+(k+k1+k2)**2) ) + 2*np.exp((1/2 *(-k-k1-k2)-1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2*(k+k1-k2+np.sqrt(-4*k*k2+(k+k1+k2)**2) ) )*(C_0-Q_in/k) )/(4*k2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )+( (-4*np.exp((1/2 *(-k-k1-k2) -1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2**2 + 4*np.exp((1/2 *(-k-k1-k2)+1/2 *np.sqrt(-4*k*k2+(k+k1+k2)**2) )*t)*k2**2 ) ( C泥_0 - (k1*Q_in)/(k*k2) ) )/(4*k2*np.sqrt(-4*k*k2+(k+k1+k2)**2) )

p = [0.00146909, 0.000965388, 0.00138934, 0.0393178, 335.867, 0]  # k,k1,k2,Q_in,C_0,C泥_0

def f(t):
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

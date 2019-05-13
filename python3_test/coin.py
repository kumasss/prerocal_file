#coin.py

class Coin():
#初期値の設定
  def __init__(self,value,type):
    self.value = value
    self.type = type
#中身の出力
  def output_info(self):
    print('総量は、%s 種類は%sです'%(self.value,self.type))
#国別の値を出力
  def exchange(self,country):
    if (country == 'JPY'):
      ex_value = self.value * 1.2
      print('日本円では')
    elif (country == 'ENG'):
      ex_value = self.value * 1.6
      print('ドルでは')
    print(ex_value)


bitcoin = Coin(4000,'BTC')
bitcoin.output_info()
bitcoin.exchange('JPY')
bitcoin.exchange('ENG')



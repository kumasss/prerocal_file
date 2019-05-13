#fizzbuzz.py


for i in range(1,100):
  string_text = ''
  if i % 3 == 0:
    string_text = string_text + 'fizz'
  if i % 5 == 0:
    string_text = string_text + 'buzz'
  if i % 3 != 0 and i % 5 != 0:
    string_text = str(i)
  print(string_text)

import datetime
import random
from faker import Faker
from pprint import pprint, pformat
# create the insert for mysql into a string to just copy paste!

fake = Faker()
#item

def item():
    file1 = open("item.txt", "w")
    for x in range(1,100001):
        I_ID = x
        I_IM_ID = x
        I_NAME = pformat("Item" + str(x))
        I_PRICE = round(random.uniform(1.00, 50.99), 2)
        I_DATA =  pformat(fake.text()[0:50])
        query =("INSERT INTO ITEM VALUES" + "(" +str(I_ID) + "," + str(I_IM_ID) + ","+ I_NAME + ","+ str(I_PRICE) + "," +
        I_DATA   + ");")
        file1.write(query)
        file1.write("\n")
    file1.close()

#stock
def stock1():
    file1 = open("stock1.txt", "w")
    for x in range(1,50000):
            S_I_ID = x
            S_W_ID = 1
            S_QUANITY = random.randint(50, 9999)
            S_DIST_01 = pformat(fake.text()[0:50])
            S_DIST_02 = pformat(fake.text()[0:50])
            S_DIST_03 = pformat(fake.text()[0:50])
            S_DIST_04 = pformat(fake.text()[0:50])
            S_DIST_05 = pformat(fake.text()[0:50])
            S_DIST_06 = pformat(fake.text()[0:50])
            S_DIST_07 = pformat(fake.text()[0:50])
            S_DIST_08 = pformat(fake.text()[0:50])
            S_DIST_09 = pformat(fake.text()[0:50])
            S_DIST_10 = pformat(fake.text()[0:50])
            S_YTD = random.randint(50, 99999999)
            S_ORDER_CNT = random.randint(50, 9999)
            S_REMOTE_CNT = random.randint(50, 9999)
            S_DATA =  pformat(fake.text()[0:50])
            query =("INSERT INTO STOCK VALUES" + "(" +str(S_I_ID) + "," + str(S_W_ID) + ","+ str(S_QUANITY) + ","+ S_DIST_01 + "," +
            S_DIST_02 + "," + S_DIST_03 + "," + S_DIST_04 + "," + S_DIST_05 + "," + S_DIST_06 + "," + S_DIST_07 + "," + S_DIST_08 + "," +
                S_DIST_09 + "," + S_DIST_10 + "," + str(S_YTD) + "," + str(S_ORDER_CNT)+ "," + str(S_REMOTE_CNT) + "," + S_DATA + ");")
            file1.write(query)
            file1.write("\n")
    file1.close()
    print("done!")
def stock12():
    file3 = open("stock12.txt", "w")
    for x in range(50000,100001):
            S_I_ID = x
            S_W_ID = 1
            S_QUANITY = random.randint(50, 9999)
            S_DIST_01 = pformat(fake.text()[0:50])
            S_DIST_02 = pformat(fake.text()[0:50])
            S_DIST_03 = pformat(fake.text()[0:50])
            S_DIST_04 = pformat(fake.text()[0:50])
            S_DIST_05 = pformat(fake.text()[0:50])
            S_DIST_06 = pformat(fake.text()[0:50])
            S_DIST_07 = pformat(fake.text()[0:50])
            S_DIST_08 = pformat(fake.text()[0:50])
            S_DIST_09 = pformat(fake.text()[0:50])
            S_DIST_10 = pformat(fake.text()[0:50])
            S_YTD = random.randint(50, 99999999)
            S_ORDER_CNT = random.randint(50, 9999)
            S_REMOTE_CNT = random.randint(50, 9999)
            S_DATA =  pformat(fake.text()[0:50])
            query =("INSERT INTO STOCK VALUES" + "(" +str(S_I_ID) + "," + str(S_W_ID) + ","+ str(S_QUANITY) + ","+ S_DIST_01 + "," +
            S_DIST_02 + "," + S_DIST_03 + "," + S_DIST_04 + "," + S_DIST_05 + "," + S_DIST_06 + "," + S_DIST_07 + "," + S_DIST_08 + "," +
                S_DIST_09 + "," + S_DIST_10 + "," + str(S_YTD) + "," + str(S_ORDER_CNT)+ "," + str(S_REMOTE_CNT) + "," + S_DATA + ");")
            file3.write(query)
            file3.write("\n")
    file3.close()
    print("done!")
def stock2():
    file2 = open("stock2.txt", "w")
    for x in range(1,50000):
            S_I_ID = x
            S_W_ID = 2
            S_QUANITY = random.randint(50, 9999)
            S_DIST_01 = pformat(fake.text()[0:50])
            S_DIST_02 = pformat(fake.text()[0:50])
            S_DIST_03 = pformat(fake.text()[0:50])
            S_DIST_04 = pformat(fake.text()[0:50])
            S_DIST_05 = pformat(fake.text()[0:50])
            S_DIST_06 = pformat(fake.text()[0:50])
            S_DIST_07 = pformat(fake.text()[0:50])
            S_DIST_08 = pformat(fake.text()[0:50])
            S_DIST_09 = pformat(fake.text()[0:50])
            S_DIST_10 = pformat(fake.text()[0:50])
            S_YTD = random.randint(50, 99999999)
            S_ORDER_CNT = random.randint(50, 9999)
            S_REMOTE_CNT = random.randint(50, 9999)
            S_DATA =  pformat(fake.text()[0:50])
            query =("INSERT INTO STOCK VALUES" + "(" +str(S_I_ID) + "," + str(S_W_ID) + ","+ str(S_QUANITY) + ","+ S_DIST_01 + "," +
            S_DIST_02 + "," + S_DIST_03 + "," + S_DIST_04 + "," + S_DIST_05 + "," + S_DIST_06 + "," + S_DIST_07 + "," + S_DIST_08 + "," +
                S_DIST_09 + "," + S_DIST_10 + "," + str(S_YTD) + "," + str(S_ORDER_CNT)+ "," +str(S_REMOTE_CNT) + "," + S_DATA + ");")
            file2.write(query)
            file2.write("\n")
    file2.close()
    print("done!")
def stock22():
    file4 = open("stock22.txt", "w")
    for x in range(50000,100001):
            S_I_ID = x
            S_W_ID = 2
            S_QUANITY = random.randint(50, 9999)
            S_DIST_01 = pformat(fake.text()[0:50])
            S_DIST_02 = pformat(fake.text()[0:50])
            S_DIST_03 = pformat(fake.text()[0:50])
            S_DIST_04 = pformat(fake.text()[0:50])
            S_DIST_05 = pformat(fake.text()[0:50])
            S_DIST_06 = pformat(fake.text()[0:50])
            S_DIST_07 = pformat(fake.text()[0:50])
            S_DIST_08 = pformat(fake.text()[0:50])
            S_DIST_09 = pformat(fake.text()[0:50])
            S_DIST_10 = pformat(fake.text()[0:50])
            S_YTD = random.randint(50, 99999999)
            S_ORDER_CNT = random.randint(50, 9999)
            S_REMOTE_CNT = random.randint(50, 9999)
            S_DATA =  pformat(fake.text()[0:50])
            query =("INSERT INTO STOCK VALUES" + "(" +str(S_I_ID) + "," + str(S_W_ID) + ","+ str(S_QUANITY) + ","+ S_DIST_01 + "," +
            S_DIST_02 + "," + S_DIST_03 + "," + S_DIST_04 + "," + S_DIST_05 + "," + S_DIST_06 + "," + S_DIST_07 + "," + S_DIST_08 + "," +
                S_DIST_09 + "," + S_DIST_10 + "," + str(S_YTD) + "," + str(S_ORDER_CNT)+ "," +str(S_REMOTE_CNT) + "," + S_DATA + ");")
            file4.write(query)
            file4.write("\n")
    file4.close()
    print("done!")

#customer
def customer():
    file1 = open("customer.txt", "w")
    #60,000
    W= 1
    D= 1
    for x in range(0,60000):
        if(x <= 3000 ):
            D = 1
            W=1
        elif (x>=3000 and x <6000):
            D =2
        elif (x>=6000 and x <9000):
            D =3
        elif (x>=9000 and x <12000):
            D =4
        elif (x>=12000 and x <15000):
            D =5
        elif (x>=15000 and x <18000):
            D =6
        elif (x>=18000 and x <21000):
            D =7
        elif (x>=21000 and x <24000):
            D =8
        elif (x>=24000 and x <27000):
            D =9
        elif (x>=27000 and x <30000):
            D =10
        elif(x >= 30000 and x <33000):
            D = 1
            W=2
        elif (x>=33000 and x <36000):
            D =2
        elif (x>=36000 and x <39000):
            D =3
        elif (x>=39000 and x <42000):
            D =4
        elif (x>=42000 and x <45000):
            D =5
        elif (x>=45000 and x <48000):
            D =6
        elif (x>=48000 and x <51000):
            D =7
        elif (x>=51000 and x <54000):
            D =8
        elif (x>=54000 and x <57000):
            D =9
        elif (x>570000):
            D =10
        C_ID = x
        C_D_ID = D
        C_W_ID = W
        #name stuff
        name  = fake.name() + " " + fake.name()
        n = name.split(" ")
        C_FIRST = pformat(n[1])
        C_MIDDLE = pformat(n[3][0:2])
        C_LAST = pformat(n[2])
        C_SREET_1 = pformat(fake.street_address())
        C_STREET_2 = pformat(fake.building_number())
        C_CITY = pformat(fake.city())
        C_STATE = pformat(fake.state_abbr())
        C_ZIP = random.randint(100000000, 999999999)
        C_PHONE = pformat('0001'+str(random.randint(100,999)) + "-" + str(random.randint(100,999)) + "-" + str(random.randint(1000,9999)))
        now = str(datetime.datetime.now())
        t = now.split('.')
        C_SINCE = pformat(t[0])
        credit = random.randrange(2)
        C_CREDIT = pformat('GC' if credit ==0 else 'BC')# GC OR BC
        C_CREDIT_LIM = round(random.uniform(1, 9999999999.99), 2)
        C_DISCOUNT = round(random.uniform(0,.5),4)
        C_BALANCE = round(random.uniform(1000, 9999999999.99), 2)
        C_YTD_PAYMENT =  round(random.uniform(500, 9999999999.99), 2)
        C_PAYMENT_CNT = random.randint(1000, 9999)
        C_DELIVERY_CNT = random.randint(1000, 9999)
        C_DATA = pformat(fake.text()[0:50])
        query =("INSERT INTO CUSTOMER VALUES" + "(" +str(C_ID) + "," + str(C_D_ID) + ","+ str(C_W_ID) + ","+ C_FIRST + "," +
        C_MIDDLE + "," + C_LAST + "," + C_SREET_1 + "," + C_STREET_2 + "," + C_CITY + "," + C_STATE + "," + str(C_ZIP) + "," +
                C_PHONE + "," + str(C_SINCE) + "," + C_CREDIT + "," + str(C_CREDIT_LIM)+  "," + str(C_DISCOUNT) + ","  + str(C_BALANCE) + "," + str(C_YTD_PAYMENT)
                +  "," +  str(C_PAYMENT_CNT) + "," + str(C_DELIVERY_CNT) + "," + C_DATA + ");")
        file1.write(query)
        file1.write("\n")
    file1.close()
    print("done!")
def district():
    file1 = open("district.txt", "w")
    for x in range(1,11):
        for y in range (1,3):
            D_ID = x
            D_W_ID = y
            D_NAME = pformat(fake.company()[0:10])
            D_STREET_1 = pformat(fake.street_address()[0:20])
            D_STREET_2 = pformat(fake.building_number()[0:20])
            D_CITY = pformat(fake.city())
            D_STATE = pformat(fake.state_abbr())
            D_ZIP = random.randint(100000000, 999999999)
            D_TAX= round(random.uniform(0,.5),4)
            D_YTD = round(random.uniform(1000000000, 9999999999.99), 2)
            D_NEXT_O_ID =1
            query = ("INSERT INTO DISTRICT VALUES" + "(" + str(D_ID) + "," + str(D_W_ID) + "," + str(
                D_NAME) + "," + D_STREET_1 + "," +
                     D_STREET_2 + "," + D_CITY + "," + D_STATE + "," + str(D_ZIP) + "," + str(D_TAX) + "," + str(D_YTD) + "," + str(
                     D_NEXT_O_ID) + ");")
            file1.write(query)
            file1.write("\n")
    file1.close()
    print("done!")

if __name__ == "__main__":
  #stock1()
  stock12()
  stock2()
  stock22()
  #customer()
  #district()
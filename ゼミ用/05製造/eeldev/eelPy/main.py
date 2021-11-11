import eel


eel.init('web')

@eel.expose
def CreateAccountControler(request):
    print(request)
    return request


# say_hello_py('Python World!')
# eel.say_hello_js('Python World!')

# eel起動
eel.start('index.html', size=(1024,768), port=10727)

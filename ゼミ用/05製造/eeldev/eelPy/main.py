import eel
from api.controller import CreateAccountControllerImpl

eel.init('web')


@eel.expose
def CreateAccountController(request):
    createAccountControllerImpl = CreateAccountControllerImpl.CreateAccountControllerImpl(request)
    return None


# say_hello_py('Python World!')
# eel.say_hello_js('Python World!')

# eel起動
eel.start('index.html', size=(1024, 768), port=10727)

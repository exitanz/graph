import eel


@eel.expose
def python_function2(a, b):
    sum = a + b
    multiplication = a * b
    return sum, multiplication


eel.init("web")
eel.start("index.html")
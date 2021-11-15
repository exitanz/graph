from api.common.ResultCode import ResultCode
from api.request.CreateAccountRequest import CreateAccountRequest


class CreateAccountControllerImpl:
    def __init__(self, request):
        print(request)
        resultCode = ResultCode.CODE000
        msg = []
        optional = []
        try:
            if len(request['user_name']) == 0 and len(request['password']) == 0:
                raise ValueError("リクエストの値が不正です。")
            createAccountRequest = CreateAccountRequest()
            if createAccountRequest.validation(self):
                raise ValueError("リクエストの値が不正です。")
        except Exception as e:
            if len(e.getMessage()) != 0:
                msg = e.getMessage()
        response = {
            "resultCode": resultCode,
            "msg": msg,
            "optional": optional
        }
        return response

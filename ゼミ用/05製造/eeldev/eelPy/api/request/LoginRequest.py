# /**
# * アカウント登録処理の値を保持する
# */
class LoginRequest:
    errorMsg = []

    # /**
    # * アカウント登録処理の値を格納します
    # */
    def __init__(self, userId, password):
        self.userId = userId
        self.password = password

    def getUserId(self):
        return self.userId

    def getPassword(self):
        return self.password

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.userId) == 0 or len(self.password) == 0):
                self.errorMsg.append('エラー ：ユーザIDまたはパスワードが入力されていません')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (2000 < len(self.userId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # パスワードの文字数チェック
            if (20 < len(self.password)):
                self.errorMsg.append('エラー ：パスワードは20文字以内で入力してください')
                validationFlg = True      

        except Exception as e:
            validationFlg = True

        return validationFlg

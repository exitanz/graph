# /**
# * アカウント登録処理の値を保持する
# */
class CreateAccountRequest:
    errorMsg = []

    # /**
    # * アカウント登録処理の値を格納します
    # */
    def __init__(self, userName, password):
        self.userName = userName
        self.password = password

    def getUserName(self):
        return self.userName

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
            if (len(self.userName) == 0 or len(self.password) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # ユーザ名の文字数チェック
            if (20 < len(self.userName)):
                self.errorMsg.append('エラー ：ユーザ名は20文字以内で入力してください')
                validationFlg = True

            # パスワードの文字数チェック
            if (20 < len(self.password)):
                self.errorMsg.append('エラー ：パスワードは20文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg

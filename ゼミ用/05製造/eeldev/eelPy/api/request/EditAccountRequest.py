from ..common.Constant import Constant


# /**
# * ユーザ編集処理の値を保持する
# */
class EditAccountRequest:
    errorMsg = []

    # /**
    # * ユーザ編集処理の値を格納します
    # */
    def __init__(self, userId, userName, password, version):
        self.userId = userId
        self.userName = userName
        self.password = password
        self.version = version

    def getUserId(self):
        return self.userId

    def getUserName(self):
        return self.userName

    def getPassword(self):
        return self.password

    def getVersion(self):
        return self.version

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.userId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザ名の文字数チェック
            if (100 < len(self.userName)):
                self.errorMsg.append('エラー ：ユーザ名は100文字以内で入力してください')
                validationFlg = True

            # パスワードの文字数チェック
            if (20 < len(self.password)):
                self.errorMsg.append('エラー ：パスワードは20文字以内で入力してください')
                validationFlg = True            

        except Exception as e:
            validationFlg = True

        return validationFlg

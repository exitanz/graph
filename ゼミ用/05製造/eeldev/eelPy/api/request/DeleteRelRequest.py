from ..common.Constant import Constant


# /**
# * 関係削除処理の値を保持する
# */
class DeleteRelRequest:
    errorMsg = []

    # /**
    # * 関係削除処理の値を格納します
    # */
    def __init__(self, relId, opusId, userId):
        self.relId = relId
        self.opusId = opusId
        self.userId = userId

    def getRelId(self):
        return self.relId

    def getOpusId(self):
        return self.opusId

    def getUserId(self):
        return self.userId

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.relId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 関係IDの文字数チェック
            if (Constant.REL_ID_DIGIT + len(Constant.REL_ID_STR) < len(self.relId)):
                self.errorMsg.append(
                    'エラー ：関係IDは' + Constant.REL_ID_DIGIT + len(Constant.REL_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg

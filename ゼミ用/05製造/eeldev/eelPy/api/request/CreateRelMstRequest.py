from ..common.Constant import Constant


# /**
# * 関係性登録処理の値を保持する
# */
class CreateRelMstRequest:
    errorMsg = []

    # /**
    # * 関係性登録処理の値を格納します
    # */
    def __init__(self, relMstName, opusId, userId):
        self.relMstName = relMstName
        self.opusId = opusId
        self.userId = userId

    def getGroupName(self):
        return self.relMstName

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
            if (len(self.relMstName) == 0 or len(self.opusId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 関係性名の文字数チェック
            if (100 < len(self.relMstName)):
                self.errorMsg.append('エラー ：関係性名は100文字以内で入力してください')
                validationFlg = True

            # 作品IDの文字数チェック
            if (Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) < len(self.opusId)):
                self.errorMsg.append(
                    'エラー ：作品IDは' + Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg

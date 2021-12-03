from ..common.Constant import Constant


# /**
# * グループ削除処理の値を保持する
# */
class DeleteGroupRequest:
    errorMsg = []

    # /**
    # * グループ削除処理の値を格納します
    # */
    def __init__(self, groupId, userId):
        self.groupId = groupId
        self.userId = userId

    def getGroupId(self):
        return self.groupId

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
            if (len(self.groupId) == 0 or len(self.userId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # グループIDの文字数チェック
            if (Constant.GROUP_ID_DIGIT + len(Constant.GROUP_ID_STR) < len(self.groupId)):
                self.errorMsg.append(
                    'エラー ：グループIDは' + Constant.GROUP_ID_DIGIT + len(Constant.GROUP_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg

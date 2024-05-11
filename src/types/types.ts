export interface UserType {
  id: number;
  username: string;
  email: string;
  created_at: string;
  relationship?: number[];
}

export interface Message {
  id: number;
  sender_id: number;
  recipient_id: number;
  message: string;
  sent_at: string;
}

export interface BasicUserType {
  id: number;
  username: string;
  email: string;
  avatar?: string;
}

export interface FullUserType {
  id: number;
  username: string;
  email: string;
  password: string;
  bio?: string;
  avatar?: string;
  location?: string;
  job?: string;
  created_at: string;
}

export interface MessageType {
  id: number;
  sender_id: number;
  recipient_id: number;
  content: string;
  created_at: string;
}

export interface PublicationType {
  id: number;
  user: BasicUserType;
  content: string;
  likes?: number; // todo
  comments?: number; // todo
  created_at: string;
}
